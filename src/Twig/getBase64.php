<?php


namespace App\Twig;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;


class getBase64 extends AbstractExtension
{
    public function getFunctions()
    {
        return [
            new TwigFunction('get_image_base64', [$this, 'getBase64Img']),
        ];
    }

    public function getBase64Img($imagePath)
    {
        if (!is_null($imagePath) && !empty($imagePath)) {
            $arrContextOptions= [
                'ssl' => [
                    'verify_peer'=> false,
                    'verify_peer_name'=> false,
                ],
            ];

            $type = pathinfo($imagePath, PATHINFO_EXTENSION);

            if($type){
                try {
                    $data = file_get_contents(
                        $imagePath,
                        false,
                        stream_context_create($arrContextOptions)
                    );

                    return'data:image/' . $type . ';base64,' . base64_encode($data);
                } catch (\Exception $e ){

                }
            }

        } else return null;
    }

}