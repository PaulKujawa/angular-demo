export interface ProductResponseDto {
    id: number;
    name: string;
    vegan: boolean;
    gr: number;
    kcal: number;
    protein: number;
    carbs: number;
    sugar: number;
    fat: number;
    gfat: number;
    manufacturer?: string;
}
