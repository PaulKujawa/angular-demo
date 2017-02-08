import {CanActivate, RouterStateSnapshot, ActivatedRouteSnapshot, Router, CanActivateChild} from '@angular/router';
import {Injectable} from '@angular/core';
import {Observable} from 'rxjs/Observable';
import {AuthService} from './auth.service';

@Injectable()
export class AuthenticationGuard implements CanActivate, CanActivateChild {
    constructor(private authService: AuthService, private router: Router) {}

    canActivate(route: ActivatedRouteSnapshot, state: RouterStateSnapshot): Observable<boolean> {
        return this.authService.isAuthenticated
            .take(1)
            .do((isAuthenticated) => {
                if (!isAuthenticated) {
                    this.authService.setTargetUrl(state.url);
                    this.router.navigate(['/login']);
                }
            });
    }

    canActivateChild(route: ActivatedRouteSnapshot, state: RouterStateSnapshot): Observable<boolean> {
        return this.canActivate(route, state);
    }
}
