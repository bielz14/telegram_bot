<?php

class Stopwatch
{
    /** @var mysqli */
    private $mysqli;
    /** @var int */
    private $stopwatch_id;
    /**
     * Stopwatch constructor
     * @param mysqli $mysqli
     * @param $stopwatch_id
     */
    public function __construct(\mysqli $mysqli, $stopwatch_id)
    {
        $this->mysqli = $mysqli;
        $this->stopwatch_id = intval($stopwatch_id);
    }

    public function start()
	{
	    $timestamp = time();
	    $query = "
	        INSERT INTO  `stopwatch` (`chat_id`, `timestamp`)
	        VALUES ('$this->stopwatch_id', '$timestamp')
	        ON DUPLICATE KEY UPDATE timestamp = '$timestamp'       
	    ";
	    return $this->mysqli->query($query);
	}

	/**
	 * Delete row with stopwatch id
	 * @return bool|mysqli_result
	 */
	public function stop()
	{
		$query = "
		    DELETE FROM `stopwatch`
		    WHERE `chat_id` = $this->stopwatch_id
		";
	    return $this->mysqli->query($query);
	}

	/**
	 * Find row with stopwatch id and return difference in seconds from saved Unix time and current time
	 * @return string
	 */
	public function status()
	{
	    $query = "
	        SELECT `timestamp` FROM  `stopwatch`
	        WHERE `chat_id` = $this->stopwatch_id        
	    ";
	    $timestamp = $this->mysqli->query($query)->fetch_row();
	    if (!empty($timestamp)) {
	        return gmdate("H:i:s", time() - reset($timestamp));
	    }
	}

	public function kurs() {

	    $json_daily_file = __DIR__.'/daily.json';
	    if (!is_file($json_daily_file) || filemtime($json_daily_file) < time() - 3600) {
	        if ($json_daily = file_get_contents('https://www.cbr-xml-daily.ru/daily_json.js')) {
	            file_put_contents($json_daily_file, $json_daily);
	        }
	    }

    	$data = json_decode(file_get_contents($json_daily_file));

    	echo "Обменный курс USD по ЦБ РФ на сегодня: {$data->Valute->USD->Value}";
	}

	
}