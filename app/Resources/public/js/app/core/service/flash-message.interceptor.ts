import {HttpErrorResponse, HttpEvent, HttpHandler, HttpInterceptor, HttpRequest} from '@angular/common/http';
import {Injectable} from '@angular/core';
import {Observable} from 'rxjs/Observable';
import {FlashMessage} from '../model/flash-message';
import {FlashMessageService} from './flash-message.service';

@Injectable()
export class FlashMessageInterceptor implements HttpInterceptor {
    constructor(private flashMessageService: FlashMessageService) {
    }

    public intercept(req: HttpRequest<any>, next: HttpHandler): Observable<HttpEvent<any>> {
        return next.handle(req)
            .catch((error: HttpErrorResponse) => {
                const message = error.error instanceof Error
                    ? 'Network or client error occurred.'
                    : `Server error occurred (Status code: ${error.status}).`;

                const flashMessage = new FlashMessage('danger', message);
                this.flashMessageService.push(flashMessage);

                return Observable.empty<HttpEvent<any>>();
            });
    }
}
