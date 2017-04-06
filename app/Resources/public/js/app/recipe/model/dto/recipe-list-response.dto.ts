import {Macros} from '../macros';
import {Photo} from '../photo';

export interface RecipeResponseDto {
    id: number;
    name: string;
    isVegan: boolean;
    macros: Macros;
    thumbnail?: Photo;
    created: string;
    updated: string;
}
