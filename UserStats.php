<?php


class UserStats{

    private $db_host = 'localhost';
    private $db_user = 'root';
    private $db_pass = '';
    private $db_name = 'adoclic';

    public function getStats($dateFrom, $dateTo, $totalClicks = null)
    {
        $conn = new mysqli($this->db_host, $this->db_user, $this->db_pass, $this->db_name);
        if($conn->connect_error){
            die('Error de conexión: ' . $conn->connect_error);
        }

        $dateFrom = $conn->real_escape_string($dateFrom);
        $dateTo = $conn->real_escape_string($dateTo);
        $totalClicks = $conn->real_escape_string($totalClicks);

        $where = " WHERE DATE(us.date) BETWEEN '$dateFrom' AND '$dateTo' AND u.status = 'active' ";
        $having = "";
        if($totalClicks !== null && $totalClicks > 0){
            $having = " HAVING total_clicks >= $totalClicks ";
        }

        $sql = "SELECT 
                CONCAT(u.first_name, ' ', u.last_name) as full_name,
                SUM(us.views) as total_views,
                SUM(us.clicks) as total_clicks,
                SUM(us.conversions) as total_conversions,
                ROUND((SUM(us.conversions) / SUM(us.clicks)) * 100, 2) as cr,
                MAX(DATE(us.date)) as last_date
                FROM user_stats us
                INNER JOIN users u ON us.user_id = u.id              
                $where           
                GROUP BY us.user_id
                $having ";

        $result = $conn->query($sql);

        $stats = [];

        if($result && $result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                $stats[] = $row;
            }
        }

        $conn->close();

        return $stats;
    }





}