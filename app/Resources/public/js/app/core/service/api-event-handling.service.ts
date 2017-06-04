import {Injectable} from '@angular/core';
import {Observable} from 'rxjs/Observable';
import {FlashMessage} from '../model/flash-message';
import {FlashMessageService} from './flash-message.service';
import {TranslationService} from './translation.service';

@Injectable()
export class ApiEventHandlerService {
    constructor(private flashMsgService: FlashMessageService,
                private translationService: TranslationService) {
    }

    public catchError(error: any): Observable<any> {
        // TODO log the error (error.message or error.statusText for instance
        // TODO check for status code to for instance redirect to login page
        this.postErrorMessage();

        return Observable.empty();
    }

    public postSuccessMessage(key: string): void {
        const message = this.translationService.trans(key);
        const flashMessage = new FlashMessage('success', message);
        this.flashMsgService.push(flashMessage);
    }

    private postErrorMessage(): void {
        const message = this.translationService.trans('TODO');
        const flashMessage = new FlashMessage('danger', message);
        this.flashMsgService.push(flashMessage);
    }
}
