<!-- Modal -->
<div class="modal fade" id="modalForm" tabindex="-1" role="dialog" data-backdrop="static">
    <div class="modal-dialog" role="document">
        <div class="modal-content" id="modal_content"></div>
    </div>
</div>
<div class="modal fade" id="modalDelete" tabindex="-1" role="dialog" data-backdrop="static">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Подтверждение удаления</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Вы действительно хотите удалить "комнату"?</p>
                <input type="hidden" id="delete_token"/>
                <input type="hidden" id="delete_id"/>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                <button type="button" class="btn btn-danger"
                        onclick="ajaxDelete('{{ url('admin/studios') }}/'+$('#delete_id').val(),$('#delete_token').val(), $('#delete_id').val())">
                    Удалить
                </button>
            </div>
        </div>
    </div>
</div>