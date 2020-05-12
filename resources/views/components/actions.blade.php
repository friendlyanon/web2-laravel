<?php /** @var \App\Utils\Slug $slug */ ?>
<?php /** @var \App\Model $item */ ?>
<?php /** @var boolean $canModify */ ?>

<td>
    <a href="{{ route("$slug->prefix.show", $slug($item)) }}"
       class="btn btn-sm btn-outline-primary"
       title="{{ __('Megtekintés') }}">
        <i class="fa fa-eye"></i>
    </a>
    @if($item->canBeEdited())
        <a href="{{ route("$slug->prefix.edit", $slug($item)) }}"
           class="btn btn-sm btn-outline-secondary"
           title="{{ __('Szerkesztés') }}">
            <i class="fa fa-pencil"></i>
        </a>
    @endif
    @if($canModify)
        <form action="{{ route("$slug->prefix.destroy", $slug($item)) }}"
              style="display: inline-block" method="POST">
            @csrf
            @method('DELETE')
            <button class="btn btn-sm btn-outline-danger"
                    title="{{ __('Törlés') }}">
                <i class="fa fa-times"></i>
            </button>
        </form>
    @endif
</td>
