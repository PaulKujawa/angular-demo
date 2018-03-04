import {ChangeDetectorRef, Component, OnDestroy, OnInit} from '@angular/core';
import {FormBuilder, FormControl, FormGroup, Validators} from '@angular/forms';
import {Subscription} from 'rxjs/Subscription';
import {FlashMessageService} from '../../core/service/flash-message.service';
import {Inquiry} from '../model/inquiry';
import {InquiryRepository} from '../repository/inquiry.repository';

@Component({
    selector: 'app-inquiry-form',
    template: `
        <form class="app-inquiry-form"
              novalidate
              [formGroup]="inquiryForm"
              (ngSubmit)="onSubmit()">
            <mat-form-field>
                <input matInput
                       formControlName="name"
                       [placeholder]="'app.inquiry.form.name'|appTrans">
            </mat-form-field>

            <mat-form-field>
                <input matInput
                       formControlName="email"
                       [placeholder]="'app.inquiry.form.email_address'|appTrans">
            </mat-form-field>

            <mat-form-field class="app-inquiry-form__message">
                <textarea matInput
                          matTextareaAutosize
                          matAutosizeMinRows="5"
                          formControlName="message"
                          [placeholder]="'app.inquiry.form.message'|appTrans">
                </textarea>
            </mat-form-field>

            <button mat-raised-button
                    color="primary"
                    [disabled]="inquiryForm.invalid">
                {{ 'app.common.submit'|appTrans }}
            </button>
        </form>
    `,
})
export class InquiryFormComponent implements OnInit, OnDestroy {
    public inquiryForm: FormGroup;
    private subscription?: Subscription;

    constructor(private formBuilder: FormBuilder,
                private changeDetectorRef: ChangeDetectorRef,
                private inquiryRepository: InquiryRepository,
                private flashMessageService: FlashMessageService) {
    }

    public ngOnInit(): void {
        const config = this.getConfig();
        this.inquiryForm = this.formBuilder.group(config);
    }

    public ngOnDestroy(): void {
        if (this.subscription) {
            this.subscription.unsubscribe();
        }
    }

    public onSubmit(): void {
        const inquiry: Inquiry = this.inquiryForm.value;

        this.subscription = this.inquiryRepository
            .postInquiry(inquiry)
            .subscribe(() => {
                this.flashMessageService.showSuccess({id: 'app.api.inquiry_success'}, 5000);
                this.changeDetectorRef.markForCheck();
            });
    }

    private getConfig(): object {
        return {
            name: '',
            email: new FormControl('', [
                Validators.required,
                Validators.email],
            ),
            message: ['', Validators.required],
        };
    }
}
