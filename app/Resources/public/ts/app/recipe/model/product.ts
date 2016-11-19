export class Product {
    constructor(public id: number,
                public name: string,
                public vegan: boolean,
                public gr: number,
                public protein: number,
                public carbs: number,
                public sugar: number,
                public fat: number,
                public gfat: number,
                public manufacturer?: string) {}
}
