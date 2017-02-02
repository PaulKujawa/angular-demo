import {Injectable} from '@angular/core';
import {Router} from '@angular/router';
import {Response} from '@angular/http';
import {Observable} from 'rxjs/Observable';
import {AuthRepository, Credentials} from '../repository/auth.repository';

@Injectable()
export class AuthService {
    private isLoggedIn = false;
    private targetUrl: string;

    constructor(private router: Router, private authRepository: AuthRepository) {
        // TODO check if cookie exists, if so set isLoggedIn to true
    }

    authenticate(credentials: Credentials): Observable<Response> {
        return this.authRepository.authenticate(credentials)
            .do(() => this.isLoggedIn = true, () => this.isLoggedIn = false);
    }

    isAuthenticated(): boolean {
        return this.isLoggedIn;
    }

    setTargetUrl(url: string): void {
        this.targetUrl = url;
    }

    navigate(): void {
        const url = this.targetUrl || '';

        if (this.targetUrl) {
            this.targetUrl = '';
        }

        this.router.navigate([url]);
    }
}
