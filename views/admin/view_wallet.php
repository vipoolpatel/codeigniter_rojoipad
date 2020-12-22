<?php
$user_id = $this->session->userdata('user_id');
    $this->load->view('admin/header');

        ?>
<style>
    #customers {
        font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
        border-collapse: collapse;
        width: 99%;
        margin-top:60px;

    }

    #customers td, #customers th {
        border: 1px solid #ddd;
        padding: 8px;
    }

    #customers tr:nth-child(even){background-color: #f2f2f2;}

    #customers tr:hover {background-color: #ddd;}

    #customers th {
        padding-top: 12px;
        padding-bottom: 12px;
        text-align: left;
        background-color: #4CAF50;
        color: white;
    }

    
    #customers1 {
        font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
        border-collapse: collapse;
        float:left;
    }

    #customers1 td, #customers1 th {
        border: 1px solid #ddd;
        padding: 8px;
    }

    #customers1 tr:nth-child(even){background-color: #f2f2f2;}

    

    #customers1 th {
        padding-top: 12px;
        padding-bottom: 12px;
        text-align: left;
        background-color: #4CAF50;
        color: white;
    }
</style>
<table id="customers">
    <th>Sr No</th>
    <th>Amount</th>
    <th>Comment</th>
<tbody>
    <?php
    if(isset($walletinfo)){
        for($i=0;$i<count($walletinfo);$i++){
            echo '<tr>';
            echo '<td>'.($i+1).'</td>';
            echo '<td>'.$walletinfo[$i]['amount'].'</td>';
            echo '<td>'.$walletinfo[$i]['comment'].'</td>';
            echo '</tr>';
        }
    }
    ?>
</tbody>
</table>

<?php $this->load->view('admin/footer') ?>
