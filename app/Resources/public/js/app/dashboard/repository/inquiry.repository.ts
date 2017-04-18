import {Http, RequestOptions, Headers} from '@angular/http';
import {Injectable} from '@angular/core';
import {Observable} from 'rxjs/Observable';
import {RoutingService} from '../../core/service/routing.service';
import {Inquiry} from '../model/inquiry';

@Injectable()
export class InquiryRepository {
    constructor(private http: Http,
                private routingService: RoutingService) {
    }

    public addInquiry(inquiry: Inquiry): Observable<void> {
        const url = this.routingService.generate('api_post_inquiry');
        const body = JSON.stringify({'inquiry': inquiry});
        const headers = new Headers({'Content-Type': 'application/json'});
        const options = new RequestOptions({headers: headers});

        return this.http.post(url, body, options)
            .map((response) => null)
            .catch((error) => Observable.throw(error.message || error.statusText));
    }
}
