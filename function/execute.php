<?php

/**
 * Class Execute
 */
class Execute
{
    /**
     * @var string
     */
    private $path_in = __DIR__ . '/../IN/';

    /**
     * @var string
     */
    private $path_out = __DIR__ . '/../OUT/';

    /**
     * @param $file
     * @return string|void
     */
    public function getContent($file)
    {
        $content = file_get_contents($this->path_in . $file);
        return $this->toArray($content);
    }

    /**
     * @param $content
     * @return SetJson|void
     */
    private function toArray($content)
    {
        //Data returned
        $data = $this->categoryName($content);

        //File name returned to access after finish process
        $file_name = $this->toJson($data);

        return $file_name;
    }

    /**
     * @param $content
     * @return array
     */
    private function categoryName($content)
    {
        $getCategory_0 = explode('</h2>', $content);
        $size_0 = sizeof($getCategory_0);
        for ($s_0 = 0; $s_0 < $size_0; $s_0++) {
            $getCategory_1 = explode('<h2', $getCategory_0[$s_0]);
            if (isset($getCategory_1[1])) {
                $getCategory_2 = explode('>', $getCategory_1[1]);
                if ($getCategory_2[1] != null) {
                    $items_cate[] = $this->items($getCategory_1[0], $getCategory_2[1]);
                }
            }
        }

        return $items_cate;
    }

    /**
     * @param $content
     * @param $category
     * @return array
     */
    private function items($content, $category)
    {
        $items = [];
        $item = [];
        $item_block = explode('menuItem___', $content);
        $size_block = sizeof($item_block);
        for ($b_0 = 1; $b_0 <= $size_block; $b_0++) {
            if (isset($item_block[$b_0] )) {
                $item['category'] = $category;

                //Get link image
                $img_0 = explode('src="', $item_block[$b_0]);
                if (isset($img_0[1])) {
                    $img_1 = explode('"', $img_0[1]);
                    $item['img'] = $img_1[0];
                } else {
                    $item['img'] =  null;
                }

                //Get name item
                $name_0 = explode('itemName___', $item_block[$b_0]);
                $name_1 = explode('</h3>', $name_0[1]);
                $name_2 = explode('>', $name_1[0]);
                $item['name'] = $name_2[2];

                //Get description item
                $description_0 = explode('itemDescription', $item_block[$b_0]);
                if (isset($description_0[1])) {
                    $description_1 = explode('</h6>', $description_0[1]);
                    $description_2 = explode('>', $description_1[0]);
                    $item['description'] = $description_2[1];
                } else {
                    $item['description'] = null;
                }

                //Get discounted item
                $discounted_0 = explode('discountedPrice', $item_block[$b_0]);
                if (isset($discounted_0[1])) {
                    $discounted_1 = explode('</h6>', $discounted_0[1]);
                    $discounted_2 = explode('>', $discounted_1[0]);
                    $item['disctount'] = $discounted_2[1];
                } else {
                    $item['disctount'] = null;
                }

                $items[] = $item;
                $item = [];
            }
        }

        return $items;
    }

    /**
     * @param $data
     * @return string
     */
    private function toJson($data)
    {
        $name = date("Y-m-d H:i:s") . ".json";
        $this->SaveFile($this->path_out . $name, json_encode($data));
        return $name;
    }

    /**
     * @param $file
     * @param $data
     */
    private function SaveFile($file, $data) {
        if (file_exists($file)) {
            chmod($file, 0777);
            unlink($file);
        }
        $fp = fopen("$file", "x+");
        fwrite($fp, "$data");
        fclose($fp);
    }
}