import {Ingredient} from '../ingredient';
import {Photo} from '../photo';
import {Cooking} from '../cooking';
import {Macros} from '../macros';

export class RecipeResponseDto {
    public id: number;
    public name: string;
    public isVegan: boolean;
    public macros: Macros;
    public created: string;
    public updated: string;
    public thumbnail?: Photo;
    public photos?: Photo;
    public ingredients?: Ingredient[];
    public cookings?: Cooking[];
}
