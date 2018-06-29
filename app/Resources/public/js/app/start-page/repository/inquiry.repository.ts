import {HttpClient} from '@angular/common/http';
import {Injectable} from '@angular/core';
import {RoutingService} from 'app/core/service/routing.service';
import {Inquiry} from 'app/start-page/model/inquiry';
import {StartPageModule} from 'app/start-page/start-page.module';
import {Observable} from 'rxjs';

@Injectable({
    providedIn: StartPageModule,
})
export class InquiryRepository {
    constructor(private http: HttpClient,
                private routingService: RoutingService) {
    }

    public postInquiry(inquiry: Inquiry): Observable<undefined> {
        const url = this.routingService.generate('api_post_inquiry');

        return this.http.post<undefined>(url, {inquiry: inquiry});
    }
}
