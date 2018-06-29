import {Doc} from 'app/core/interface/doc.interface';
import {Pageable} from 'app/core/model/pageable';
import {Observable} from 'rxjs';

export abstract class PageableState {
    public abstract getPageable(): Observable<Pageable<Doc>>;
}
