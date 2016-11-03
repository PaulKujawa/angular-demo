import {Component} from '@angular/core';
import {Inquiry} from "../model/inquiry";
import {InquiryRepository} from "../repository/inquiry.repository";
import {FlashMessage} from "../../core/model/flash-message";
import {FlashMessageService} from "../../core/service/flash-message.service";
import {TranslationService} from "../../core/service/translation.service";

@Component({
    selector: 'inquiry-form',
    providers: [InquiryRepository],
    template: `
        <form #inquiryForm="ngForm" (ngSubmit)="onSubmit()">
            <div class="row flex">
                <div class="col-xs-12 col-sm-5">
                    <div class="form-group">
                        <input class="form-control" type="text" 
                        placeholder="{{'app.inquiry.form.name'|trans}}" 
                        name="name" [(ngModel)]="inquiry.name">
                    </div>
                    <div class="form-group">
                        <input class="form-control" type="email" required 
                        placeholder="{{'app.inquiry.form.email_address'|trans}}"
                        name="email" [(ngModel)]="inquiry.email">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-7">
                    <div class="form-group">
                        <textarea class="form-control ba-inquiry__message" required
                        placeholder="{{'app.inquiry.form.message'|trans}}"
                        #message="ngModel"
                        name="message" [(ngModel)]="inquiry.message"></textarea>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-7 col-sm-offset-5">
                    <div class="pull-right">
                        <button type="submit" class="btn btn-primary" [disabled]="!inquiryForm.form.valid">
                            {{'app.common.submit'|trans}}
                        </button>
                    </div>
                </div>
            </div>
        </form>
    `
})
export class InquiryFormComponent {
    inquiry: Inquiry = new Inquiry('', '');

    constructor(private inquiryRepository: InquiryRepository,
                private flashMsgService: FlashMessageService,
                private translationService: TranslationService) {}

    onSubmit() {
        this.inquiryRepository.addInquiry(this.inquiry)
            .subscribe(
                () => {
                    const message = new FlashMessage(
                        'success',
                        this.translationService.trans('app.inquiry.inquiry_sent')
                    );
                    this.flashMsgService.push(message);
                },
                (error: string) => this.flashMsgService.push(new FlashMessage('danger', error))
            );
    }
}
