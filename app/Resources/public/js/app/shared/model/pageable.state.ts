import {Observable} from 'rxjs/Observable';
import {Doc} from '../../core/interface/doc.interface';
import {Pageable} from '../../core/model/pageable';

export abstract class PageableState {
    public abstract getPageable(): Observable<Pageable<Doc>>;
}
