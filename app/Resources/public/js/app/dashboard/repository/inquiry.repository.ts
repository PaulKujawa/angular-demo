import {HttpClient} from '@angular/common/http';
import {Injectable} from '@angular/core';
import {Observable} from 'rxjs/Observable';
import {ApiEventHandler} from '../../core/service/api-event.handler';
import {RoutingService} from '../../core/service/routing.service';
import {Inquiry} from '../model/inquiry';

@Injectable()
export class InquiryRepository {
    constructor(private http: HttpClient,
                private apiEventHandler: ApiEventHandler,
                private routingService: RoutingService) {
    }

    public postInquiry(inquiry: Inquiry): Observable<void> {
        const url = this.routingService.generate('api_post_inquiry');

        return this.http.post<void>(url, {inquiry: inquiry})
            .do(() => this.apiEventHandler.postSuccessMessage('app.api.inquiry_success'))
            .catch((error) => this.apiEventHandler.catchError(error));
    }
}
