export class ProductDto {
    id: number;
    name: string;
    vegan: boolean;
    gr: number;
    protein: number;
    carbs: number;
    sugar: number;
    fat: number;
    gfat: number;
    created: Date;
    updated: Date;
    manufacturer?: string;
}
