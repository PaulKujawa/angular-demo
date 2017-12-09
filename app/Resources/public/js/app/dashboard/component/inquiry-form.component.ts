import {ChangeDetectorRef, Component, OnDestroy, OnInit} from '@angular/core';
import {FormBuilder, FormControl, FormGroup, Validators} from '@angular/forms';
import {Subscription} from 'rxjs/Subscription';
import {FlashMessage} from '../../core/model/flash-message';
import {FlashMessageService} from '../../core/service/flash-message.service';
import {TranslationService} from '../../core/service/translation.service';
import {Inquiry} from '../model/inquiry';
import {InquiryRepository} from '../repository/inquiry.repository';

@Component({
    selector: 'inquiry-form',
    template: `
        <form class="app-inquiry-form"
              novalidate
              [formGroup]="inquiryForm"
              (ngSubmit)="onSubmit()">
            <div class="row">
                <div class="col-xs-12 col-sm-5">
                    <mat-form-field>
                        <input matInput
                               formControlName="name"
                               [placeholder]="'app.inquiry.form.name'|trans">
                    </mat-form-field>

                    <mat-form-field>
                        <input matInput
                               formControlName="email"
                               [placeholder]="'app.inquiry.form.email_address'|trans">
                    </mat-form-field>
                </div>

                <div class="col-xs-12 col-sm-7">
                    <mat-form-field class="app-inquiry-form__message">
                        <textarea matInput
                                  matTextareaAutosize
                                  matAutosizeMinRows="5"
                                  formControlName="message"
                                  [placeholder]="'app.inquiry.form.message'|trans">
                        </textarea>
                    </mat-form-field>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12 col-sm-offset-5 col-sm-7">
                    <div class="app-inquiry-form__submit">
                        <button mat-raised-button
                                color="primary"
                                [disabled]="inquiryForm.invalid">
                            {{'app.common.submit' | trans}}
                        </button>
                    </div>
                </div>
            </div>
        </form>
    `,
})
export class InquiryFormComponent implements OnInit, OnDestroy {
    public inquiryForm: FormGroup;
    private subscription?: Subscription;

    constructor(private formBuilder: FormBuilder,
                private changeDetectorRef: ChangeDetectorRef,
                private inquiryRepository: InquiryRepository,
                private translationService: TranslationService,
                private flashMessageService: FlashMessageService) {
    }

    public ngOnInit(): void {
        this.inquiryForm = this.formBuilder.group({
            name: '',
            email: new FormControl('', [Validators.required, Validators.email]),
            message: ['', Validators.required],
        });
    }

    public ngOnDestroy(): void {
        this.subscription && this.subscription.unsubscribe();
    }

    public onSubmit(): void {
        const inquiry = this.map(this.inquiryForm.value);

        this.subscription = this.inquiryRepository
            .postInquiry(inquiry)
            .subscribe(() => {
                const message = this.translationService.trans('app.api.inquiry_success');
                const flashMessage = new FlashMessage('success', message);
                this.flashMessageService.push(flashMessage);
                this.changeDetectorRef.markForCheck();
            });
    }

    private map(model: Inquiry): Inquiry {
        return {
            message: model.message,
            email: model.email,
            name: model.name,
        };
    }
}
