<h2>User List</h2>

<br /><br />

<table class="table table-bordered">
    <tr>
        <th>No</th>
        <th>Username</td>
        <th>Email</td>
        <th>First name</td>
        <th>Last Name</td>
        <th>Division</td>
        <th>Active Status</td>
        <th>Action</td>
    </tr>
    <?php
    $no = 0;
    $aktif_status = '';
    $button_activate = '';
    foreach ($record->result() as $r) {
        if ($r->is_activated == 1) {
            $aktif_status = 'Active';
            $button_activate = '';
        } else {
            $aktif_status = 'Not Active';
            $button_activate = anchor('user/activate/'.$r->id, 'Activate it!', ['class' => 'btn btn-success btn-sm']);
        }
        $no++;
        echo "<tr>
            <td>$no</td>
            <td>$r->username</td>
            <td>$r->email</td>
            <td>$r->first_name</td>
            <td>$r->last_name</td>
            <td>$r->division</td>
            <td>$aktif_status</td>
            <td>".
                $button_activate
            ."</td>
        </tr>";
    }
    ?>
</table>