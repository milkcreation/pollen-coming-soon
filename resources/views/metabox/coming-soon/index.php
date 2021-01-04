<?php
/**
 * @var tiFy\Metabox\MetaboxViewInterface $this
 */
?>
<table class="Form-table">
    <tr>
        <th>
            <?php _e('Rendre le site accessible aux utilisateurs connectés.', 'pollen-coming-soon'); ?>
        </th>
        <td>
            <?php echo field('toggle-switch', [
                'name'  => $this->getName(),
                'value' => $this->getValue()
            ]); ?>
        </td>
    </tr>
</table>