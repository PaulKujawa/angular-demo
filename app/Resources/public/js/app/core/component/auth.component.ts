import {Component} from '@angular/core';
import {FormBuilder, FormControl, FormGroup, Validators} from '@angular/forms';
import {Credentials} from '../repository/auth.repository';
import {AuthenticationService} from '../service/authentication.service';

@Component({
    template: `
        <form novalidate
              [formGroup]="authForm"
              (ngSubmit)="onSubmit()"
              class="app-auth">
            <mat-form-field>
                <input autofocus
                       matInput
                       [placeholder]="'security.login.username'|appTrans"
                       formControlName="username">
            </mat-form-field>

            <mat-form-field>
                <input type="password"
                       matInput
                       [placeholder]="'security.login.password'|appTrans"
                       formControlName="password">
            </mat-form-field>

            <button mat-raised-button
                    color="primary"
                    [disabled]="authForm.invalid">
                {{ 'app.common.submit'|appTrans }}
            </button>
        </form>
    `,
})
export class AuthComponent {
    public authForm: FormGroup;

    constructor(private authenticationService: AuthenticationService,
                formBuilder: FormBuilder) {
        this.authForm = formBuilder.group({
            username: new FormControl('', Validators.required),
            password: new FormControl('', Validators.required),
        });
    }

    public onSubmit(): void {
        const credentials: Credentials = this.authForm.value;

        this.authenticationService
            .authenticate(credentials)
            .subscribe(() => this.authenticationService.navigateToTargetUrl());
    }
}
