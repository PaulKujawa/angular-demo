import {Component} from '@angular/core';

@Component({
    selector: 'inquiry',
    template: `
        <div class="row flex flex-align-v text-center">
            <div class="col-xs-12 col-sm-5">
                <img class="img-circle center-block img-responsive" src="../../images/kujawa.jpg">
            </div>
            <div class="col-xs-12 col-sm-7">
                <p>Heimprojekt mit ein paar Rezepten.</p>
            </div>
        </div>
        <hr>
        <inquiry-form></inquiry-form>
    `
})
export class InquiryComponent {
    // TODO fix image path
}