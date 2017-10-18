<td>
    @for ($i = 0; $i < intval($entry->{$column['name']}); $i++)
        <i class="fa fa-star"></i>
    @endfor
    @for ($i = 0; $i < (5 - intval($entry->{$column['name']})); $i++)
        <i class="fa fa-star-o"></i>
    @endfor
</td>