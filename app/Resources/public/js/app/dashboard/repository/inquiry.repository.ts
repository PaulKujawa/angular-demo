import {HttpClient} from '@angular/common/http';
import {Injectable} from '@angular/core';
import {Observable} from 'rxjs/Observable';
import {RoutingService} from '../../core/service/routing.service';
import {Inquiry} from '../model/inquiry';

@Injectable()
export class InquiryRepository {
    constructor(private http: HttpClient,
                private routingService: RoutingService) {
    }

    public postInquiry(inquiry: Inquiry): Observable<undefined> {
        const url = this.routingService.generate('api_post_inquiry');

        return this.http.post<undefined>(url, {inquiry: inquiry});
    }
}
