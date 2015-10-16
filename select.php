


Umowa: <select>
    <?php

    $pdo = new PDO('mysql:dbname=infoshareaca_7;host=test.payments.infoshareaca.nazwa.pl', 'infoshareaca_7', 'F0r3v3r!');
    $stmt = $pdo->query('SELECT id, companyName FROM contract');
    $contracts = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // pol do bazy dancyh\
    // wykonac select wszystkich contraktow
    // dla kazdego kontraktu pobranego

    foreach ($contracts as $one_contract){
        echo  '<option value="'.$one_contract['id'].'" ';
        if(isset($selected_contract)) {
            $selected_contract = $one_contract['id'];
            echo 'selected';
        }
        echo '>'.$one_contract['companyName'].'</option>';
    }
    print_r($contracts);
    ?>
</select><br>