<?php 

namespace HelpCenter_Intergrations;

use Vendasta\Vax\Auth\FetchVendastaAuthToken;

/**
 * Class HelpCenter_Client
 *
 * @since 1.1.0
 * @package HelpCenter_Intergrations
 */
class HelpCenter_Client 
{

    public function index_article($articleId, $origin){        
        $vendasta_auth = new FetchVendastaAuthToken(VENDASTA_API_ENV);
		$mToken =  $vendasta_auth->fetchToken();

        $ch = curl_init();
        curl_setopt_array($ch, array(
            CURLOPT_URL => VENDASTA_API_CONFIGS['url'].'/helpcenter.v1.HelpCenter/IndexArticle',
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'POST',
			CURLOPT_POSTFIELDS => '{
                "articleId": "'.$articleId.'",
                "locale": "en-us",
                "origin": "'.$origin.'"
            }',
			CURLOPT_HTTPHEADER => array(
				'Authorization: Bearer '.$mToken,
				'Content-Type: application/json'
			),
            // CURLOPT_FAILONERROR => true // Required for HTTP error codes to be reported via our call to curl_error($ch)
		));

        curl_exec($ch);
        // if (curl_errno($ch)) {
        //     $error_msg = curl_error($ch);
        // }
        curl_close($ch);

        // if (isset($error_msg)) {
        //     print_r($error_msg);
        //     // die();
        //     throw new Exception('Some error occured while indexing');
        // } 
    }

    public function delete_article($articleId, $origin){
        $vendasta_auth = new FetchVendastaAuthToken(VENDASTA_API_ENV);
		$mToken =  $vendasta_auth->fetchToken();
        
        $ch = curl_init();
        curl_setopt_array($ch, array(
			CURLOPT_URL =>  VENDASTA_API_CONFIGS['url'].'/helpcenter.v1.HelpCenter/DeleteArticle',
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'POST',
			CURLOPT_POSTFIELDS => '{
                "articleId": "'.$articleId.'",
                "locale": "en-us",
                "origin": "'.$origin.'"
            }',
			CURLOPT_HTTPHEADER => array(
				'Authorization: Bearer '.$mToken,
				'Content-Type: application/json'
			),
		));

        curl_exec($ch);
        curl_close($ch);
    }

    public function search_article( $search_term ){
        $vendasta_auth = new FetchVendastaAuthToken(VENDASTA_API_ENV);
		$mToken =  $vendasta_auth->fetchToken();

		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => VENDASTA_API_CONFIGS['url'].'/helpcenter.v1.HelpCenter/SearchArticle',
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'POST',
			CURLOPT_POSTFIELDS => '{
				"searchTerm": "'.$search_term.'",
				"locale": "en-us",
				"filters": {
					"origins": [
						"ORIGINS_RESOURCE_CENTER_ZENDESK",
						"ORIGINS_VIDEO_WP",
						"ORIGINS_BP_MEMBERS_WP",
						"ORIGINS_BP_GROUP_WP",
						"ORIGINS_PODCASTS_WP",
                        "ORIGINS_COMMUNITY_POST_ZENDESK"
					]
				},
				"pagingOptions": {
					"cursor": "",
					"pageSize": 500
				}
			}',
			CURLOPT_HTTPHEADER => array(
				'Authorization: Bearer '.$mToken,
				'Content-Type: application/json'
			),
		));

		$response = curl_exec($curl);
		curl_close($curl);

        return $response;
	}
}
