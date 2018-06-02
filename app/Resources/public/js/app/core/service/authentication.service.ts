import {Inject, Injectable} from '@angular/core';
import {Router} from '@angular/router';
import {AuthenticatedInjectToken} from 'app/core/core.token';
import {AuthRepository, Credentials} from 'app/core/repository/auth.repository';
import {Observable, ReplaySubject} from 'rxjs';
import {tap} from 'rxjs/operators';

@Injectable()
export class AuthenticationService {
    public isAuthenticated = new ReplaySubject<boolean>(1);
    private targetUrl: string;

    constructor(@Inject(AuthenticatedInjectToken) authenticated: boolean,
                private router: Router,
                private authRepository: AuthRepository) {
        this.isAuthenticated.next(authenticated);
    }

    public authenticate(credentials: Credentials): Observable<undefined> {
        // on failure: authentication did not change
        return this.authRepository.authenticate(credentials)
            .pipe(
                tap(() => this.isAuthenticated.next(true)),
            );
    }

    public setTargetUrl(url: string): void {
        this.targetUrl = url;
    }

    public navigateToTargetUrl(): void {
        const url = this.targetUrl || '';
        this.targetUrl = '';

        this.router.navigate([url]);
    }
}
