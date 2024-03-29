
<?php

function selectData($selectedItemId) {

    $pdo = DBHandler::getPDO();
    $stmt = $pdo->query('SELECT id, companyName FROM contract');
    $contracts = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $selected_contract = $selectedItemId;

    $data = [];
    foreach ($contracts as $one_contract) {
        $data[$one_contract['id']] = [
            'value' => $one_contract['id'],
            'label' => $one_contract['companyName'],
            'isSelected' => (isset($selected_contract) && $selected_contract == $one_contract['id'])
        ];
    }

    return $data;
}