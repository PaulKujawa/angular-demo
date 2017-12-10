import {Observable} from 'rxjs/Observable';
import {Pageable} from '../../core/model/pageable';
import {Doc} from '../../core/interface/doc.interface';

export abstract class PageableState {
    public abstract getPageable(): Observable<Pageable<Doc>>;
}
