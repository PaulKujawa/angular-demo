import {Injectable} from '@angular/core';
import {ActivatedRouteSnapshot, CanActivate, CanActivateChild, Router, RouterStateSnapshot} from '@angular/router';
import {Observable} from 'rxjs/Observable';
import {AuthenticationService} from './authentication.service';

@Injectable()
export class AuthenticationGuard implements CanActivate, CanActivateChild {
    constructor(private authenticationService: AuthenticationService, private router: Router) {
    }

    public canActivate(route: ActivatedRouteSnapshot, state: RouterStateSnapshot): Observable<boolean> {
        return this.authenticationService.isAuthenticated
            .take(1)
            .do((isAuthenticated) => {
                if (!isAuthenticated) {
                    this.authenticationService.setTargetUrl(state.url);
                    this.router.navigate(['/login']);
                }
            });
    }

    public canActivateChild(route: ActivatedRouteSnapshot, state: RouterStateSnapshot): Observable<boolean> {
        return this.canActivate(route, state);
    }
}
