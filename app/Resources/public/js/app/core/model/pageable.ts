import {Pagination} from './pagination';

export interface Doc {
    id: number;
}

/**
 * @see PageableFactory
 */
export class Pageable<T extends Doc> {
    constructor(public pagination: Pagination,
                public docs: T[]) {
    }

    public hasDoc(id: number): boolean {
        return this.docs.findIndex((doc) => doc.id === id) !== -1;
    }

    public getIndex(id: number): number {
        return this.docs.findIndex((doc) => doc.id === id);
    }

    public replaceDoc(doc: T): void {
        const i = this.getIndex(doc.id);
        if (i === -1) {
            return;
        }

        this.docs.splice(i, 1, doc);
    }

    public removeDoc(id: number): void {
        const i = this.getIndex(id);
        if (i === -1) {
            return;
        }

        this.docs.splice(i, 1);
    }
}
