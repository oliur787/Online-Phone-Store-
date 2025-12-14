// WinterDiscount.php
class WinterDiscount implements DiscountStrategy {
    public function calculateDiscount($price) {
        return $price * 0.20;  // 20% winter discount
    }
}
 