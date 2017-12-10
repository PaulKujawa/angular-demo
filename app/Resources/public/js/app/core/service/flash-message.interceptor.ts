import {HttpErrorResponse, HttpEvent, HttpHandler, HttpInterceptor, HttpRequest} from '@angular/common/http';
import {Injectable} from '@angular/core';
import {Observable} from 'rxjs/Observable';
import {FlashMessageService} from './flash-message.service';

@Injectable()
export class FlashMessageInterceptor implements HttpInterceptor {
    constructor(private flashMessageService: FlashMessageService) {
    }

    public intercept(req: HttpRequest<any>, next: HttpHandler): Observable<HttpEvent<any>> {
        return next.handle(req)
            .catch((error: HttpErrorResponse) => {
                const message = error.error instanceof Error
                    ? {id: 'app.api.network_error'}
                    : {id: 'app.api.server_error', parameters: {error: error.status}};

                this.flashMessageService.showFailure(message);

                return Observable.empty<HttpEvent<any>>();
            });
    }
}
