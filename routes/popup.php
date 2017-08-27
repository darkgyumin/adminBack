<?php
$app->get('/popup', function ($request, $response) {
    $param = $request->getParams();
	$param = $this->common->nvl($param, 'searchKey', '');
	$param = $this->common->nvl($param, 'searchWord', '');

    //count
    $sql = 'SELECT COUNT(*) AS cnt FROM wm_popup ';
	$sql .= 'WHERE 0 = 0 ';
	if($param['searchKey'] && $param['searchWord']) 
		$sql .= 'AND '.$param['searchKey'].' LIKE \'%'.$param['searchWord'].'%\'';
    $stmt = $this->pdo->prepare($sql);
    //execute
    $stmt->execute();
    $data = $stmt->fetch();
    
    //paging setting
    $param['total_record'] = $data['cnt'];

	$param = $this->common->nvl($param, 'page', 1);
	$param = $this->common->nvl($param, 'listNum', 10);
	$param = $this->common->nvl($param, 'blockNum', 10);

    //paging setting
    $this->paging->setPaging($param);
   
    $sql = 'SELECT popup_idx, title, content, start_date, end_date, ';
	$sql .= 'popup_width, popup_height, write_id, FROM_UNIXTIME(write_date, \'%Y-%m-%d\') as write_date, ';
	$sql .= 'write_ip FROM wm_popup ';
	$sql .= 'WHERE 0 = 0 ';
	if($param['searchKey'] && $param['searchWord']) 
		$sql .= 'AND '.$param['searchKey'].' LIKE \'%'.$param['searchWord'].'%\'';
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
	$json['first_page'] = $this->paging->first_page;
	$json['last_page'] = $this->paging->last_page;

    $json['status'] = '200';
	$json['message'] = 'success';
	$json['rowCount'] = $stmt->rowCount();
	$json['data'] = $data;

    $response->withJson($json, 200);
});