
<table>
    <tr><th>id</th><th>name</th></tr>
    <?php foreach ($posts as $post): ?>
        <tr>
            <td><?php echo $post['id']?></td>
            <td><?php echo $post['name']?></td>
        </tr>
    <?php endforeach; ?>
</table>
