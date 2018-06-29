import {HttpErrorResponse, HttpEvent, HttpHandler, HttpInterceptor, HttpRequest} from '@angular/common/http';
import {Injectable} from '@angular/core';
import {CoreModule} from 'app/core/core.module';
import {FlashMessageService} from 'app/core/service/flash-message.service';
import {Observable} from 'rxjs';
import {tap} from 'rxjs/operators';

@Injectable({
    providedIn: CoreModule,
})
export class FlashMessageInterceptor implements HttpInterceptor {
    constructor(private flashMessageService: FlashMessageService) {
    }

    public intercept(req: HttpRequest<any>, next: HttpHandler): Observable<HttpEvent<any>> {
        return next.handle(req)
            .pipe(
                tap(undefined, (error: HttpErrorResponse) => {
                    const message = error.error instanceof Error
                        ? {id: 'app.api.network_error'}
                        : {id: 'app.api.server_error', parameters: {error: error.status}};

                    this.flashMessageService.showFailure(message);
                }),
            );
    }
}
