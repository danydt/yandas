<?php


namespace App\Http\Traits;


trait CodeGeneratorTrait
{

    /**
     * @param null $actualCode
     * @param int $len
     * @return string|null
     */
    protected function transactionCodeGenerator($actualCode = null, int $len = 20):?string
    {
        // if there is no transaction code yet
        // then return a $len code with 1 at the then
        // eg: 00000001
        if (is_null($actualCode) || $actualCode == 0) {

            if (!$len) {
                return null;
            }

            return sprintf("%s%d", str_repeat(0, $len - 1), 1);

        }

        // check the len of actual code
        // it must be equal to the $len
        if (!strlen($actualCode) == $len) {

            return null;
        }

        // now start

        $iterations = $len - 1;
        $numbers = range(0, 9);

        NTP_TREATMENT:

        // getting the current index for treatment
        // the current index is based on the $iterations
        // the $iterations is decremented each time
        $current_index = array_search($actualCode[$iterations], $numbers);

        // increment the $current_index;
        $current_index ++;

        // if there is a number corresponding to the current index
        // then increment $actualCode at the $iteration index by the $current_index value
        // $numbers contains numbers from 0 to 9
        // $current_index can go up to 10
        // if so, set $actualCode to 0 at the $iteration index
        // otherwise, make other verifications to increase the correct index and decrease the correct one
        if ( isset($numbers[$current_index])) {

            $actualCode[$iterations] = $numbers[$current_index];

        } else {

            // first check if there is an index behind the current index
            // if yes, that index must have as value 0
            if (isset($actualCode[$iterations + 1]) && $actualCode[$iterations + 1] == 0) {

                goto NTP_FINISH;

                // or check if there is simply an index behind the current index
            } elseif (!isset($actualCode[$iterations + 1])) {

                goto NTP_FINISH;

                // else go to the end
            } else {

                goto NTP_RETURN;
            }

            NTP_FINISH:
            // first set $actualCode to 0 at the $iteration index
            $actualCode[$iterations] = $numbers[0]; // $numbers[0] = 0

            // decrease $iterations value
            $iterations --;

            if ($iterations >= 0)
                goto NTP_TREATMENT;
        }

        NTP_RETURN:

        return $actualCode;
    }
}
