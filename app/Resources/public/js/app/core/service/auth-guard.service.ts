import {Injectable} from '@angular/core';
import {
    ActivatedRouteSnapshot, CanActivate, CanActivateChild, CanLoad, Route, Router,
    RouterStateSnapshot
} from '@angular/router';
import {Observable} from 'rxjs/Observable';
import {AuthenticationService} from './authentication.service';

@Injectable()
export class AuthenticationGuard implements CanActivate, CanActivateChild, CanLoad {
    constructor(private authenticationService: AuthenticationService, private router: Router) {
    }

    public canLoad(route: Route): Observable<boolean> {
        const targetUrl = `/${route.path}`;

        return this.isAuthenticated(targetUrl);
    }

    public canActivate(route: ActivatedRouteSnapshot, state: RouterStateSnapshot): Observable<boolean> {
        return this.isAuthenticated(state.url);
    }

    public canActivateChild(route: ActivatedRouteSnapshot, state: RouterStateSnapshot): Observable<boolean> {
        return this.canActivate(route, state);
    }

    private isAuthenticated(targetUrl: string): Observable<boolean> {
        return this.authenticationService.isAuthenticated
            .take(1)
            .do((isAuthenticated) => {
                if (!isAuthenticated) {
                    this.authenticationService.setTargetUrl(targetUrl);
                    this.router.navigate(['/login']);
                }
            });
    }
}
