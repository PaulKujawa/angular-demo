import {HttpEvent, HttpHandler, HttpInterceptor, HttpRequest} from '@angular/common/http';
import {Injectable} from '@angular/core';
import {CoreModule} from 'app/core/core.module';
import {Observable} from 'rxjs';

@Injectable({
    providedIn: CoreModule,
})
export class HeadersInterceptor implements HttpInterceptor {
    public intercept(req: HttpRequest<any>, next: HttpHandler): Observable<HttpEvent<any>> {
        req = req.clone({
            setHeaders: {
                'Content-Type': 'application/json',
            },
        });

        return next.handle(req);
    }
}
