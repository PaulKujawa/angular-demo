import {Component} from '@angular/core';

@Component({
    template: `
        <div class="row">
            <div class="col-xs-12 col-sm-5 app-inquiry">
                <img class="app-inquiry__image"
                     src="../../images/kujawa.jpg">
            </div>

            <div class="col-xs-12 col-sm-7">
                <inquiry-form></inquiry-form>
            </div>
        </div>
    `,
})
export class InquiryComponent {
    // TODO fix image path
}
