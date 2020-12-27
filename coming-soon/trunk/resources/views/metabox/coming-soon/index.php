<?php
/**
 * @var tiFy\Contracts\Metabox\MetaboxView $this
 */
?>
<table class="Form-table">
    <tr>
        <th>
            <?php _e('Rendre le site accessible aux utilisateurs connectés.', 'pollen-coming-soon'); ?>
        </th>
        <td>
            <?php echo field('toggle-switch', [
                'name'  => $this->name(),
                'value' => $this->value()
            ]); ?>
        </td>
    </tr>
</table>