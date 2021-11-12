<?php

namespace App\Controller;

use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use League\Csv\Writer;


class DefaultController extends AbstractController
{
    /**
     * @Route("/")
     */
    public function root(): Response
    {
        return $this->render("form.html.twig");
    }

    /**
     * @Route("/generate_codes.csv")
     */
    public function generateCodesCsv(): Response
    {
        $availableChars = $_POST["available_chars"];
        $lenCodes = intval($_POST["len_codes"]);
        $numCodes = intval($_POST["num_codes"]);

        $header = array("id", "code");
        $codesArray = $this->genCodesArray($availableChars, $lenCodes, $numCodes);

        $csv = Writer::createFromString();
        $csv->insertOne($header);
        $csv->insertAll($codesArray);

        return new Response($csv->toString(), Response::HTTP_OK, ['content-type' => 'text/csv']);
    }

    /**
     * @throws Exception
     */
    public function genCodesArray($availableChars, $lenCodes, $numCodes): array
    {
        $charsArray = array_unique(str_split($availableChars));

        // prevent infinite loop
        if($numCodes > count($charsArray)**$lenCodes){
            throw new Exception("Too many codes demanded");
        }

        $codes = array();
        $id = 0;
        while(count($codes) < $numCodes){
            $code = "";
            for($i=0; $i<$lenCodes; $i++){
                $idx = random_int(0, count($charsArray)-1);
                $code .= $charsArray[$idx];
            }
            if(!in_array($code, $codes)){
                array_push($codes, array(++$id, $code));
            }
        }
        return $codes;
    }
}