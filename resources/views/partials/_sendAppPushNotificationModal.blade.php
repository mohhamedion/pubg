<!-- SEND PUSH NOTIFICATION MODAL -->
<div class="modal fade" id="sendPushNotificationModal" tabindex="-1" role="dialog"
     aria-labelledby="sendPushNotificationModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"
                        aria-label="Close"><span>&times;</span></button>
                <h4 class="modal-title"
                    id="sendPushNotificationModalLabel">@lang('labels.send_push_notification')</h4>
            </div>
            <div class="modal-body">
                                    <textarea class="form-control"
                                              name="pushMessage"
                                              title="Push notification text"
                                              id="pushMessage" cols="30"
                                              rows="10"></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default"
                        data-dismiss="modal">@lang('labels.buttons.close')</button>
                <button type="button"
                        id="sendAppPushNotification"
                        data-url="{{ $url }}"
                        data-id="{{ $application->id }}"
                        class="btn btn-primary">@lang('labels.buttons.send')</button>
            </div>
        </div>
    </div>
</div>