import {Injectable} from '@angular/core';
import {Router} from '@angular/router';
import {Response} from '@angular/http';
import {Observable} from 'rxjs/Observable';
import {ReplaySubject} from 'rxjs/ReplaySubject';
import {AuthRepository, Credentials} from '../repository/auth.repository';

@Injectable()
export class AuthenticationService {
    public isAuthenticated = new ReplaySubject<boolean>(1);
    private targetUrl: string;

    constructor(private router: Router, private authRepository: AuthRepository) {
        this.isAuthenticated.next(window.appInject.authenticated);
    }

    public authenticate(credentials: Credentials): Observable<Response> {
        // on failure: authentication did not change
        return this.authRepository.authenticate(credentials)
            .do(() => this.isAuthenticated.next(true));
    }

    public setTargetUrl(url: string): void {
        this.targetUrl = url;
    }

    public navigate(): void {
        const url = this.targetUrl || '';
        this.targetUrl = '';

        this.router.navigate([url]);
    }
}
