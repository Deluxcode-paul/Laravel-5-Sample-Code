$(function () {
    var tree = $('#tree');

    $.ajaxSetup({headers: {'X-CSRF-TOKEN': pagesTree.config.csrfToken}});

    tree.tree({
        data: pagesTree.config.tree,
        dragAndDrop: true,
        autoOpen: true,
        selectable: false,
        useContextMenu: false,
        onCreateLi: function (node, $li) {
            $li.find('.jqtree-element')
                .prepend('<i class="fa fa-arrows"></i>')
                .append(
                    '<div class="jqtree-controls">' +
                    '<a title="preview" href="' + node.previewUrl + '" target="_blank" class="preview" ><i class="fa fa-search"></i></a>' +
                    '<a title="edit" href="/admin/cms/' + node.id + '/edit" class="edit" ><i class="fa fa-pencil"></i></a>' +
                    '<a title="construct" href="' + node.constructUrl + '" class="construct" ><i class="fa fa-th-list"></i></a>' +
                    '<a title="delete" href="' + node.deleteUrl + '" class="delete-btn"><i class="fa fa-trash"></i></a>' +
                    '</div>'
                );
        }
    });

    // bind event for tree elements moving
    tree.bind('tree.move', function (e) {
        var data = {
            'moved_node': e.move_info.moved_node.id,
            'target_node': e.move_info.target_node.id,
            'position': e.move_info.position,
            'previous_parent': e.move_info.previous_parent.id
        };
        $.ajax({
            method: 'post',
            url: pagesTree.config.routes.move,
            data: data,
            success: function (data) {
                tree.tree('loadData', JSON.parse(data));
            }
        });
    });

    // toggle visibility
    tree.on('click', '.toggle-visibility', function (e) {
        var $this = $(this);
        var isPublished = $this.data('published');

        $this.html(isPublished ? '<i class="fa fa-eye"></i>' : '<i class="fa fa-eye-slash"></i>');
        $this.data('published', isPublished ? 0 : 1);

        $.ajax({
            method: 'post',
            url: pagesTree.config.routes.visibility,
            data: {pageId: $this.data('pageId')},
            success: function (data) {
                $($this.closest('.jqtree-element')[0]).find('a.preview').attr('href', data);
            }
        });
    });

    // show confirmation before page deleting
    tree.on('click', '.delete-btn', function (e) {
        if (false == confirm('Are you sure you want to delete this page? All child pages (if any) will be also deleted.')) {
            e.preventDefault();
        }
    });
});