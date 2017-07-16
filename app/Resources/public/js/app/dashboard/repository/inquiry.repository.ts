import {Injectable} from '@angular/core';
import {Http} from '@angular/http';
import {Observable} from 'rxjs/Observable';
import {RoutingService} from '../../core/service/routing.service';
import {ApiEventHandler} from '../../core/service/api-event.handler';
import {Inquiry} from '../model/inquiry';

@Injectable()
export class InquiryRepository {
    constructor(private http: Http,
                private apiEventHandler: ApiEventHandler,
                private routingService: RoutingService) {
    }

    public postInquiry(inquiry: Inquiry): Observable<void> {
        const url = this.routingService.generate('api_post_inquiry');

        return this.http.post(url, {inquiry: inquiry})
            .do(() => this.apiEventHandler.postSuccessMessage('app.api.inquiry_success'))
            .map((response) => undefined)
            .catch((error) => this.apiEventHandler.catchError(error));
    }
}
