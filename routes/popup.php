<?php
$app->get('/popup', function ($request, $response) {
    $param = $request->getParams();

    //count
    $sql = 'SELECT COUNT(*) AS cnt FROM wm_popup';
    $stmt = $this->pdo->prepare($sql);
    //execute
    $stmt->execute();
    $data = $stmt->fetch();
    
    //paging setting
    $param['total_record'] = $data['cnt'];
    if(!array_key_exists('page', $param) || !$param['page']) $param['page'] = 1;
    if(!array_key_exists('listNum', $param) || !$param['listNum']) $param['listNum'] = 15;
    if(!array_key_exists('blockNum', $param) || !$param['blockNum']) $param['blockNum'] = 10;
    //paging setting
    $this->paging->setPaging($param);
   
    $sql = 'SELECT popup_idx, title, content, start_date, end_date, popup_width, popup_height, write_id, FROM_UNIXTIME(write_date, \'%Y-%m-%d\') as write_date, write_ip FROM wm_popup ';
    $sql .= 'LIMIT '.$this->paging->first.', '.$param['listNum'].' ';
    $stmt = $this->pdo->prepare($sql);
    //execute
    $stmt->execute();
    $data = $stmt->fetchAll();

    $json['total_record'] = $param['total_record'];
    $json['page'] = $param['page'];
    $json['paging'] = $this->paging->paging;
    $json['total_page'] = $this->paging->total_page;
    $json['num'] = $this->paging->num;

    $json['status'] = '200';
	$json['message'] = 'success';
	$json['rowCount'] = $stmt->rowCount();
	$json['data'] = $data;

    $response->withJson($json, 200);
});