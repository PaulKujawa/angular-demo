import {Injectable} from '@angular/core';
import {
    ActivatedRouteSnapshot, CanActivate, CanActivateChild, CanLoad, Route, Router,
    RouterStateSnapshot,
} from '@angular/router';
import {CoreModule} from 'app/core/core.module';
import {AuthenticationService} from 'app/core/service/authentication.service';
import {Observable} from 'rxjs';
import {take, tap} from 'rxjs/operators';

@Injectable({
    providedIn: CoreModule,
})
export class AuthenticationGuard implements CanActivate, CanActivateChild, CanLoad {
    constructor(private authenticationService: AuthenticationService,
                private router: Router) {
    }

    public canLoad(route: Route): Observable<boolean> {
        const targetUrl = `/${route.path}`;

        return this.isAuthenticated(targetUrl);
    }

    // @ts-ignore
    public canActivate(route: ActivatedRouteSnapshot, state: RouterStateSnapshot): Observable<boolean> {
        return this.isAuthenticated(state.url);
    }

    public canActivateChild(route: ActivatedRouteSnapshot, state: RouterStateSnapshot): Observable<boolean> {
        return this.canActivate(route, state);
    }

    private isAuthenticated(targetUrl: string): Observable<boolean> {
        return this.authenticationService.isAuthenticated
            .pipe(
                take(1),
                tap((isAuthenticated) => {
                    if (!isAuthenticated) {
                        this.authenticationService.setTargetUrl(targetUrl);
                        this.router.navigate(['/login']);
                    }
                }),
            );
    }
}
