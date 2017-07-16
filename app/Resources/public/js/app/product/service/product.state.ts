import {ReplaySubject} from 'rxjs/ReplaySubject';
import {Pageable} from '../../core/model/pageable';
import {Product} from '../model/product';

export class ProductState {
    public pageable = new ReplaySubject<Pageable<Product>>(1);

    public replaceProductById(product: Product): void {
        this.pageable
            .take(1)
            .subscribe((pageable) => {
                const i = pageable.docs.findIndex((doc) => doc.id === product.id);

                if (i === -1) {
                    return; // TODO exception worthy
                }

                pageable.docs.splice(i, 1, product);
                this.pageable.next(pageable);
            });
    }

    public addProduct(product: Product): void {
        this.pageable
            .take(1)
            .subscribe((pageable) => {
                pageable.docs.push(product);
                this.pageable.next(pageable);
            });
    }

    public removeProduct(id: number): void {
        this.pageable
            .take(1)
            .subscribe((pageable) => {
                const i = pageable.docs.findIndex((doc) => doc.id === id);

                if (i === -1) {
                    return; // TODO exception worthy
                }

                pageable.docs.splice(i, 1);
                this.pageable.next(pageable);
            });
    }
}
