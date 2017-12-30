import {Component} from '@angular/core';

@Component({
    template: `
        <div class="app-inquiry">
            <div class="app-inquiry__image">
                <img class="app-inquiry-image__item"
                     src="../../images/kujawa.jpg">
            </div>

            <inquiry-form></inquiry-form>
        </div>
    `,
})
export class InquiryComponent {
    // TODO fix image path
}
