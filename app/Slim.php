<?php
namespace App;

abstract class SlimStatus {
    const FAILURE = 'failure';
    const SUCCESS = 'success';
}

class Slim {

    public static function s3save($filepath, $filename) {
        $s3 = \Storage::disk('s3');
        $s3->put($filename, file_get_contents($filepath), 'public');
        return \Storage::disk('s3')->url($filename);
    }

    public static function publicSave($filepath, $filename, $driver = 'public') {
        $local = \Storage::disk($driver);
        $local->put($filename, file_get_contents($filepath), 'public');
        return \Storage::disk($driver)->url($filename);
    }

    public static function slimCropImageAndSaveToS3($fieldname, $deleted, $oldValue)
    {
        /* USING SLIM API
        * 1. save to tmp folder using slim api for processing cropped image
        * 2. upload processed image to s3
        * 3. delete file in tmp folder
        */
        $images = Slim::getImages($fieldname);

        if($images){
            $image = $images[0];

            // let's create some shortcuts
            $name = $image['input']['name'];
            $data = $image['output']['data'];

            //fix filename
            $name = str_replace(' ', '-', $name);

            //1. store the file
            $file = Slim::saveFile($data, $name);
            $filepath = $file['path'];
            $filename = $file['name'];

            //2. store in s3
            $image_path = Slim::s3save($filepath, $filename);

            //3. NEED TO DELETE TEMP FILE SAVED IN /public/tmp AFTER IMAGE HAS BEEN SUCCESSFULLY SAVED IN S3
            unlink($filepath);

            return $image_path;
        }

        if($deleted){
            return '';
        }
        else{
            return $oldValue;
        }
    }


     public static function slimCropImageAndSave($fieldname, $driver='admins', $oldValue='', $fieldValue='')
    {
        /* USING SLIM API
        * 1. save to tmp folder using slim api for processing cropped image
        * 2. upload processed image to local storage
        * 3. delete file in tmp folder
        */
        $images = array();

        if(!$fieldValue){
            $images = Slim::getImages($fieldname);
        }
        else {
            $inputValue = Slim::parseInput($fieldValue);
            if ($inputValue) {
                array_push($images, $inputValue);
            }
        }
        

        if($images){
            $image = $images[0];

            // let's create some shortcuts
            $name = $image['input']['name'];
            $data = $image['output']['data'];

            //fix filename
            $name = str_replace(' ', '-', $name);

            //1. store the file
            $file = Slim::saveFile($data, $name);
            $filepath = $file['path'];
            $filename = $file['name'];

            //2. store in s3
            $image_path = Slim::publicSave($filepath, $filename, $driver);

            //3. NEED TO DELETE TEMP FILE SAVED IN /public/tmp AFTER IMAGE HAS BEEN SUCCESSFULLY SAVED IN S3
            unlink($filepath);

            return $image_path;
        } else {
            return $oldValue;
        }

    }


    public static function getImages($inputName = 'slim') {

        $values = Slim::getPostData($inputName);

        // test for errors
        if ($values === false) {
            return false;
        }

        // determine if contains multiple input values, if is singular, put in array
        $data = array();
        if (!is_array($values)) {
            $values = array($values);
        }

        // handle all posted fields
        foreach ($values as $value) {
            $inputValue = Slim::parseInput($value);
            if ($inputValue) {
                array_push($data, $inputValue);
            }
        }

        // return the data collected from the fields
        return $data;

    }

    // $value should be in JSON format
    private static function parseInput($value) {

        // if no json received, exit, don't handle empty input values.
        if (empty($value)) {return null;}

        // The data is posted as a JSON String so to be used it needs to be deserialized first
        $data = json_decode($value);

        // shortcut
        $input = null;
        $actions = null;
        $output = null;
        $meta = null;

        if (isset ($data->input)) {
            $inputData = isset($data->input->image) ? Slim::getBase64Data($data->input->image) : null;
            $input = array(
                'data' => $inputData,
                'name' => $data->input->name,
                'type' => $data->input->type,
                'size' => $data->input->size,
                'width' => $data->input->width,
                'height' => $data->input->height,
            );
        }

        if (isset($data->output)) {
            $outputData = isset($data->output->image) ? Slim::getBase64Data($data->output->image) : null;
            $output = array(
                'data' => $outputData,
                'width' => $data->output->width,
                'height' => $data->output->height
            );
        }

        if (isset($data->actions)) {
            $actions = array(
                'crop' => $data->actions->crop ? array(
                    'x' => $data->actions->crop->x,
                    'y' => $data->actions->crop->y,
                    'width' => $data->actions->crop->width,
                    'height' => $data->actions->crop->height,
                    'type' => $data->actions->crop->type
                ) : null,
                'size' => $data->actions->size ? array(
                    'width' => $data->actions->size->width,
                    'height' => $data->actions->size->height
                ) : null
            );
        }

        if (isset($data->meta)) {
            $meta = $data->meta;
        }

        // We've sanitized the base64data and will now return the clean file object
        return array(
            'input' => $input,
            'output' => $output,
            'actions' => $actions,
            'meta' => $meta
        );
    }

    // $path should have trailing slash
    public static function saveFile($data, $name, $path = 'tmp/', $uid = true) {

        // Add trailing slash if omitted
        if (substr($path, -1) !== '/') {
            $path .= '/';
        }

        // Test if directory already exists
        if(!is_dir($path)){
            mkdir($path, 0755, true);
        }

        // Let's put a unique id in front of the filename so we don't accidentally overwrite older files
        if ($uid) {
            $name = uniqid() . '_' . $name;
        }

        // Add name to path, we need the full path including the name to save the file
        $path = $path . $name;

        // store the file
        Slim::save($data, $path);

        // return the files new name and location
        return array(
            'name' => $name,
            'path' => $path
        );
    }

    public static function outputJSON($data) {
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    /**
     * Gets the posted data from the POST or FILES object. If was using Slim to upload it will be in POST (as posted with hidden field) if not enhanced with Slim it'll be in FILES.
     * @param $inputName
     * @return array|bool
     */
    private static function getPostData($inputName) {

        $values = array();

        if (isset($_POST[$inputName])) {
            $values = $_POST[$inputName];
        }
        else if (isset($_FILES[$inputName])) {
            // Slim was not used to upload this file
            return false;
        }

        return $values;
    }

    /**
     * Saves the data to a given location
     * @param $data
     * @param $path
     */
    private static function save($data, $path) {
        file_put_contents($path, $data);
    }

    /**
     * Strips the "data:image..." part of the base64 data string so PHP can save the string as a file
     * @param $data
     * @return string
     */
    private static function getBase64Data($data) {
        return base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $data));
    }

}