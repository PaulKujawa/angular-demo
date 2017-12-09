import {Component} from '@angular/core';

@Component({
    template: `
        <div class="row app-inquiry">
            <div class="col-xs-12 col-sm-5">
                <img class="app-inquiry__image"
                     src="../../images/kujawa.jpg">
            </div>

            <div class="col-xs-12 col-sm-7">
                <p>{{'app.inquiry.description'|trans}}</p>
            </div>
        </div>
        <hr>

        <inquiry-form></inquiry-form>
    `,
})
export class InquiryComponent {
    // TODO fix image path
}
