import {Component} from '@angular/core';
import {AuthRepository} from "../repository/auth.repository";
import {Jwt} from "../model/jwt";
import {AuthService} from "../service/auth.service";
import {FlashMessage} from "../../core/model/flash-message";
import {FlashMessageService} from "../../core/service/flash-message.service";
import {TranslationService} from "../../core/service/translation.service";

@Component({
    selector: 'auth',
    template: `
        <div class="row">
            <div id="loginPage">
                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-4 col-sm-offset-3 col-md-offset-4">
                        <form #authForm="ngForm" (ngSubmit)="onSubmit()"> 
                            <div class="form-group">
                                <input type="text" required autofocus class="form-control" 
                                placeholder="{{'security.login.username'|trans}}" 
                                name="username" [(ngModel)]="credentials.username"/>
                            </div>
                            <div class="form-group">
                                <input type="password" required class="form-control" 
                                placeholder="{{'security.login.password'|trans}}"
                                name="password" [(ngModel)]="credentials.password"/>
                            </div>
                            <div class="form-group">
                                <button type="submit" [disabled]="!authForm.form.valid" 
                                class="btn btn-primary btn-block">
                                    {{'app.common.submit'|trans}}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    `
})
export class AuthComponent {
    credentials = {username: '', password: ''};

    constructor(private authRepository: AuthRepository,
                private authService: AuthService,
                private flashMsgService: FlashMessageService,
                private translationService: TranslationService) {}

    onSubmit(): void {
        this.authRepository.authenticate(this.credentials)
            .subscribe(
                (jwt: Jwt) => {
                    this.authService.setJwt(jwt);
                    const message = new FlashMessage(
                        'success',
                        this.translationService.trans('app.auth.signed_in')
                    );
                    this.flashMsgService.push(message);
                },
                (error: string) => this.flashMsgService.push(new FlashMessage('danger', error))
            );
    }
}
