export class Photo {
    constructor(public id: number,
                public size: number,
                public path: string,
                public created: Date,
                public updated: Date) {}
}
