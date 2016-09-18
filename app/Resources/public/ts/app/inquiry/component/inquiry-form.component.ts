import {Component} from '@angular/core';
import {Inquiry} from "../model/inquiry";
import {InquiryRepository} from "../repository/inquiry.repository";
import {FlashMessage} from "../../core/model/flash-message";
import {FlashMessageService} from "../../core/service/flash-message.service";

@Component({
    selector: 'inquiry-form',
    providers: [InquiryRepository],
    template: `
        <form (ngSubmit)="onSubmit()" #inquiryForm="ngForm">
            <div class="row flex">
                <div class="col-xs-12 col-sm-5">
                    <div class="form-group">
                        <input class="form-control" type="text" placeholder="Ihr Name" 
                        name="name" [(ngModel)]="inquiry.name">
                    </div>
                    <div class="form-group">
                        <input class="form-control" type="email" required placeholder="Ihre E-Mail Adresse"
                        name="email" [(ngModel)]="inquiry.email">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-7">
                    <div class="form-group">
                        <textarea class="form-control ba-inquiry__message" required placeholder="Ihre Nachricht an mich"
                        name="message" [(ngModel)]="inquiry.message" #message="ngModel"></textarea>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-7 col-sm-offset-5">
                    <div class="pull-right">
                        <button type="submit" class="btn btn-primary" [disabled]="!inquiryForm.form.valid">
                            Absenden
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
                private flashMsgService: FlashMessageService) {}

    onSubmit() {
        this.inquiryRepository.addInquiry(this.inquiry)
            .subscribe(
                inquiry => this.flashMsgService.push(new FlashMessage('success', 'Ich habe deine Mitteilung erhalten.')),
                error => this.flashMsgService.push(new FlashMessage('danger', error))
            );
    }
}
