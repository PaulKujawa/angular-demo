import {Component} from '@angular/core';

@Component({
    template: `
        <div class="app-inquiry">
            <div class="app-inquiry__image">
                <img class="app-inquiry-image__item"
                     src="../../images/kujawa.jpg">
            </div>

            <app-inquiry-form></app-inquiry-form>
        </div>
    `,
})
export class InquiryComponent {
    // TODO fix image path
}
